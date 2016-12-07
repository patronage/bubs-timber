#!/bin/bash

## On error, quit
set -e

## GIT Remote Variables
STAGING_REMOTE="git@git.wpengine.com:staging/bubs.git"
PRODUCTION_REMOTE="git@git.wpengine.com:production/bubs.git"

## Branch for continuous dev deployment (also update .travis.yml)
DEV_BRANCH="staging"

## SH function to read txt files with list of files to include/exclude

getArray() {
    i=0
    while read line # Read a line
    do
        array[i]=$line # Put it into the array
        i=$(($i + 1))
    done < $1
}

## build script
if [[ -n $(git status --porcelain) ]]; then
    echo "There are uncommited changes -- please commit before proceeding with testing"
elif [ ! -z "$TRAVIS_BRANCH" ] && [ "$TRAVIS_PULL_REQUEST" != "false" ]; then
    echo "This is a pull request, don't build"
else

    ## on travis, add credentials
    if [ ! -z "$TRAVIS_BRANCH" ]; then
        echo -e "Host git.wpengine.com\n\tStrictHostKeyChecking no\n" >> ~/.ssh/config
        git config --global user.email "accounts@patronage.org"
        git config --global user.name "Patronage"
    fi

    if [ `git branch --list deploy` ]; then
       echo "Branch deploy already exists, deleting then continuing"
       git branch -D deploy
    fi

    #save current branch to a variable
    branch=$(git branch | sed -n -e 's/^\* \(.*\)/\1/p')

    git checkout -b deploy
    gulp release

    echo "Adding built files that are normally .gitignored..."
    array=()
    getArray "_build/.deploy_include.txt"
    for e in "${array[@]}"
    do
        printf "$e\n"
        git add "$e" -f
    done

    echo "Removing files we don't want on the server"
    array=()
    getArray "_build/.deploy_exclude.txt"
    for e in "${array[@]}"
    do
        git rm -r "$e"
    done

    echo "Committing build changes"
    git commit -m "Committing build changes"

    ## travis deploy based on branch
    if [ "$TRAVIS_BRANCH" = "master" ]; then
        echo "Pushing to production..."
        git remote add production ${PRODUCTION_REMOTE}
        git push -f production deploy:master

    elif [ ! -z "$TRAVIS_BRANCH" ]; then
        echo "Pushing to staging..."
        git remote add staging ${STAGING_REMOTE}
        git push -f staging deploy:master

    elif [ "$1" = "staging" ]; then
        echo "Pushing to staging..."
        git remote add staging ${STAGING_REMOTE}
        git push -f staging deploy:master
        echo "Returning to working branch..."
        git stash
        git checkout $branch

    elif [ "$1" = "production" ]; then
        echo "Pushing to production..."
        git remote add production ${PRODUCTION_REMOTE}
        git push -f production deploy:master
        echo "Returning to working branch..."
        git stash
        git checkout $branch

    else
        echo "No deploy condition met"
    fi

    ## test for git response, and if error code, bail out of travis with an error code
    success=$?
    if [[ $success -eq 0 ]];
    then
        echo "Great success!"
    else
        echo "Something went wrong with the deploy"
        exit 1
        echo "should have exited by now"
    fi
fi

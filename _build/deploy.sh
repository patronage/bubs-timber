#!/bin/bash

## env export, with unset at end of script
if [ -f ".env" ]; then
  export $(grep -v '^#' .env | xargs)
else
  echo ".env file required"
  exit 1;
fi


## Per Project Variables -- CUSTOMIZE THESE FIRST IN .ENV
PRODUCTION_REMOTE="git@git.wpengine.com:production/${COMPOSE_WPE_PRODUCTION}.git"
STAGING_REMOTE="git@git.wpengine.com:production/${COMPOSE_WPE_STAGING}.git"
DEVELOPMENT_REMOTE="git@git.wpengine.com:production/${COMPOSE_WPE_DEVELOPMENT}.git"

# Defined in .env
# GIT_EMAIL="hello+bubs@patronage.org"
# GIT_NAME="Bubs Deploy"

# read txt files with list of files to include/exclude
function get_array {
  i=0
  while read line # Read a line
  do
    array[i]=$line # Put it into the array
    i=$(($i + 1))
  done < $1
}

# handle script errors, exit and kick you to working branch
function error_exit {
  echo "$1" 1>&2
  echo "Aborting and returning to working branch."
  git stash
  git checkout $branch
  exit 1
}

# check environment to ensure we should proceed with build
if [[ -n $(git status --porcelain) ]]; then
  error_exit "There are uncommited changes -- please commit before proceeding."
else

  if [ `git branch --list deploy` ]; then
    echo "Branch deploy already exists, deleting then continuing"
    git branch -D deploy
  fi

  # save current branch to a variable
  branch=$(git branch | sed -n -e 's/^\* \(.*\)/\1/p')

  git checkout -b deploy
  npx gulp release || error_exit "Gulp release failed."

  echo "Adding built files that are normally .gitignored..."
  array=()
  get_array "_build/.deploy_include.txt"
  for e in "${array[@]}"
  do
    printf "$e\n"
    git add "$e" -f
  done

  echo "Removing files we don't want on the server"
  array=()
  get_array "_build/.deploy_exclude.txt"
  for e in "${array[@]}"
  do
    git rm -r --ignore-unmatch "$e"
  done

  echo "Committing build changes"
  git commit -m "Committing build changes"

  if [ "$1" = "staging" ]; then
    echo "Pushing to staging: ${STAGING_REMOTE}..."
    git remote rm staging
    git remote add staging ${STAGING_REMOTE}
    git push -f staging deploy:master
    echo "Returning to working branch."
    git stash
    git checkout $branch

  elif [ "$1" = "development" ]; then
    echo "Pushing to development: ${DEVELOPMENT_REMOTE}..."
    git remote rm development
    git remote add development ${DEVELOPMENT_REMOTE}
    git push -f development deploy:master
    echo "Returning to working branch."
    git stash
    git checkout $branch

  elif [ "$1" = "production" ]; then
    echo "Pushing to production: ${PRODUCTION_REMOTE}..."
    git remote rm production
    git remote add production ${PRODUCTION_REMOTE}
    git push -f production deploy:master
    echo "Returning to working branch."
    git stash
    git checkout $branch

  else
    error_exit "No deploy conditions met."
  fi

  ## test for git response, and if error code, bail out of travis with an error code
  success=$?
  if [[ $success -eq 0 ]];
  then
    echo "Build script complete"
  else
    error_exit "Something went wrong with the deploy."
  fi
fi

if pgrep gulp >/dev/null 2>&1
then
  echo "Rebuilding gulp dev assets"
  npx gulp restart
fi

if [ -f ".env" ]; then
  unset $(grep -v '^#' .env | sed -E 's/(.*)=.*/\1/' | xargs)
fi

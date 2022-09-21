#!/bin/sh

## env export, with unset at end of script
if [ -f ".env" ]; then
  export $(grep -v '^#' .env | xargs)
else
  echo ".env file required, please copy from the .env.sample"
  exit 1;
fi

## Per Project Variables -- CUSTOMIZE THESE FIRST IN .ENV
WORDPRESS_DB_USER="root"
WORDPRESS_DB_PASSWORD="somewordpress"
WORDPRESS_DB_NAME=${COMPOSE_PROJECT_NAME:-wordpress}
DB_CONTAINER="${COMPOSE_PROJECT_NAME:-wordpress}_db_1"
PRODUCTION_SSH="${COMPOSE_WPE_PRODUCTION}@${COMPOSE_WPE_PRODUCTION}.ssh.wpengine.net"

# handle script errors, exit and kick you to working branch
function error_exit {
  echo "$1" 1>&2
  echo "Aborting export attempt"
  exit 1
}

function db_import() {
  sql=`ls -Art _data/* | tail -n 1`
  echo $sql
  ext=${sql##*.}

  if [ $ext = "zip" ]; then
    unzip -p $sql | docker exec -i $DB_CONTAINER mysql -u $WORDPRESS_DB_USER -p$WORDPRESS_DB_PASSWORD -D $WORDPRESS_DB_NAME
  elif [ $ext = "gz" ]; then
    gunzip < $sql | docker exec -i $DB_CONTAINER mysql -u $WORDPRESS_DB_USER -p$WORDPRESS_DB_PASSWORD -D $WORDPRESS_DB_NAME
  else
    docker exec -i $DB_CONTAINER mysql -u $WORDPRESS_DB_USER -p$WORDPRESS_DB_PASSWORD -D $WORDPRESS_DB_NAME < $sql
  fi

  # run local mods if present
  file="_data/local.sql"
  if [ -f "$file" ]
  then
    docker exec -i $DB_CONTAINER mysql -u $WORDPRESS_DB_USER -p$WORDPRESS_DB_PASSWORD -D $WORDPRESS_DB_NAME < $file
    echo "$file imported."
  else
    echo "$file not found."
  fi

  if [ -f ".env" ]; then
    unset $(grep -v '^#' .env | sed -E 's/(.*)=.*/\1/' | xargs)
  fi

  echo 'import complete'
}

function db_export() {
  local TARGET=${1}

  if [ "$TARGET" = "staging" ]; then
    SSH_TARGET=$STAGING_SSH
  elif [ "$TARGET" = "production" ]; then
    SSH_TARGET=$PRODUCTION_SSH
  elif [ "$TARGET" = "development" ]; then
    SSH_TARGET=$DEVELOPMENT_SSH
  else
    error_exit "Export task requires a target. Specify a target (staging, development, production)"
  fi

  echo "connecting to $SSH_TARGET"

  status=$(ssh -o BatchMode=yes -o ConnectTimeout=5 $SSH_TARGET echo ok 2>&1)

  if [[ $status == ok ]] ; then
    echo "auth ok, proceeding with export"
    if ! command -v wp &> /dev/null
    then
      error_exit "'wp' command could not be found. WP CLI local install required to export DB"
    else
      mkdir -p _data
      filename=$(date +'%Y-%m-%d-%H-%M-%S').sql.zip
      wp db export --add-drop-table --ssh=$SSH_TARGET - | gzip > _data/$(date +'%Y-%m-%d-%H-%M-%S').sql.gz
      echo "export complete";
    fi
  elif [[ $status == "Permission denied"* ]] ; then
    echo no_auth
  elif [[ $status == "Host key verification failed"* ]] ; then
    echo "host key not yet verified, please run: ssh $SSH_TARGET then try again"
  else
    echo "SSH couldn't connect, please check that environments are defined in your .env, and your SSH key is added to WP Engine"
  fi
}

CALLED_FUNCTION=${1}
TARGET=${2}

if [ "$CALLED_FUNCTION" = "export" ]; then
  echo "Running DB export for $TARGET"
  db_export $TARGET
elif [ "$CALLED_FUNCTION" = "import" ]; then
  echo "running DB import script"
  db_import
else
  error_exit "Specify a DB task (export or import)"
fi

if [ -f ".env" ]; then
  unset $(grep -v '^#' .env | sed -E 's/(.*)=.*/\1/' | xargs)
fi

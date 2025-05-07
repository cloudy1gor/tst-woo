#!/bin/bash

# Load environment variables from .env file
export $(grep -v '^#' .env | xargs)

_os="$(uname)"
_now=$(date +"%m_%d_%Y")
_input_dir="./dump"  # Folder where the dump is stored
_file="$_input_dir/data_$_now.sql"  # The filename of the dump

# Check if variables are set
if [ -z "$WORDPRESS_DB_NAME" ]; then
  echo "❌ WORDPRESS_DB_NAME is not set."
  exit 1
fi

if [ -z "$WORDPRESS_DB_ROOT_PWD" ]; then
  echo "❌ WORDPRESS_DB_ROOT_PWD is not set."
  exit 1
fi

# Check if the dump file exists
if [ ! -f "$_file" ]; then
  echo "❌ Dump file $_file does not exist."
  exit 1
fi

# Print variables for debugging
echo "WORDPRESS_DB_NAME: $WORDPRESS_DB_NAME"
echo "WORDPRESS_DB_ROOT_PWD: $WORDPRESS_DB_ROOT_PWD"
echo "_input_dir is: '$_input_dir'"
echo "_file is: '$_file'"

echo "Importing WordPress database from $_file..."

# Import the dump into the MySQL container
if docker-compose exec \
  -e MYSQL_PWD="$WORDPRESS_DB_ROOT_PWD" \
  mysql \
  sh -c "mysql -uroot $WORDPRESS_DB_NAME < $_file"; then

  echo "✅ Dump imported successfully."
else
  echo "❌ Failed to import dump."
  exit 1
fi

#!/bin/bash

# Load environment variables from .env file
export $(grep -v '^#' .env | xargs)

_os="$(uname)"
_now=$(date +"%m_%d_%Y")
_output_dir="./dump"  # <-- Changed to 'dump' folder
_file="$_output_dir/data_$_now.sql"

# Check if variables are set
if [ -z "$WORDPRESS_DB_NAME" ]; then
  echo "❌ WORDPRESS_DB_NAME is not set."
  exit 1
fi

if [ -z "$WORDPRESS_DB_ROOT_PWD" ]; then
  echo "❌ WORDPRESS_DB_ROOT_PWD is not set."
  exit 1
fi

# Print variables for debugging
echo "WORDPRESS_DB_NAME: $WORDPRESS_DB_NAME"
echo "WORDPRESS_DB_ROOT_PWD: $WORDPRESS_DB_ROOT_PWD"
echo "_output_dir is: '$_output_dir'"
echo "_file is: '$_file'"

mkdir -p "$_output_dir"  # Ensure the 'dump' folder exists

echo "Exporting WordPress database..."
if docker-compose exec \
  -e MYSQL_PWD="$WORDPRESS_DB_ROOT_PWD" \
  mysql \
  sh -c "mysqldump $WORDPRESS_DB_NAME -uroot" > "$_file"; then

  echo "✅ Dump saved to $_file"

  if [[ $_os == "Darwin"* ]]; then
    sed -i '.bak' 1d "$_file"
    rm "$_file.bak"
  else
    sed -i '1d' "$_file"
  fi

  echo "✅ Password warning removed."
else
  echo "❌ Failed to export database."
  exit 1
fi

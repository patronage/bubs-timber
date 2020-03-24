# _SQL Folder

Docker will auto-load files here the first time the Docker instance is started. Once you restart Docker, whatever the previous state of MySQL was will be preserved. 

To update the SQL here, please remove the current `.sql` file with a date. Don't remove `localhosting.sql`. Then add the new one, with the naming convention `%YYYY%MM%DD.sql`.

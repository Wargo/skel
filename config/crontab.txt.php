# use /bin/sh to run commands, no matter what /etc/passwd says
SHELL=/bin/sh
# mail any output to 'techyperson', no matter whose crontab this is
MAILTO=techyperson@example.com

# If the relative path to cake doesn't work (if your app folder is itself (in) a symlink) - make it absolute

# Run some cake shell once a week, email the output to techyperson@example.com
0 0 0 * * (cd /var/www/vhosts/example.com/www/apps/live; ../cake/console/cake some_shell)

# Backup the db daily, no email
#
# Daily is way too frequent - change to weekly or whatever whenever your app is stable
# If you want somewhere offsite and cheap to store your backup files try http://www.dreamhost.com/r.cgi?291143
0 0 * * * (scp $(cd /var/www/vhosts/example.com/www/apps/live; ../cake/console/cake mi_db backup complete -bz2 -q -app `pwd`) backupserver:backups/database/) > /dev/null 2>&1
# variant for if you've mounted the backup server
# 0 0 * * * (mv $(cd /var/www/vhosts/example.com/www/apps/live; ../cake/console/cake mi_db backup complete -bz2 -q -app `pwd`) /mnt/backups/example/database/) > /dev/null 2>&1

# Maintaina backup of all uploaded files (only the pristine originals) daily, no email
0 0 * * * (rsync -qruHtz --safe-links /var/www/vhosts/example.com/www/apps/live/uploads/ backupserver:backups/uploads/) > /dev/null 2>&1

# Every 3 hours clear the data and view cache completely, no email
# Clear only files older than an hour from the webroot cache - to stagger activity
0 */3 * * * * (rm -rf /tmp/thisappname/cache/data/*; rm -rf /tmp/thisappname/cache/views/*; find /var/www/vhosts/example.com/www/apps/live/webroot/cache/ -mmin +360 | xargs rm -rf) > /dev/null 2>&1
# Dummy comment to ensure the last cron command ends with a newline
git clone ...

composer update

cp app/config/parameters.yml.dist app/config/parameters.yml

if you want an auth uncomment in config.yml line 3

cp app/config/security.yml.dist app/config/security.yml (uncomment)

sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx  ...

sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx  ...
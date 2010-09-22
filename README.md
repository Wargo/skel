# Skel. App skeleton for a new app

This repository is intented to be used as a template for new projects, i.e. you'd ordinarily make use of this repo like so:

	cd www/apps
	cake bake newproject -skel /path/to/this/repo

# Functionality

It's pretty basic, but includes:

* Basic user management (register, forgotten password, administration)
* An admin panel
* example usage for each of the dependent plugins

# Dependencies

This empty app assume the existance of the following plugins:

* mi
* mi_asset
* mi_email
* mi_enums
* mi_panel
* mi_settings
* mi_users

And this vendor 
* mi_js
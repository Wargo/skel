# Skel. App skeleton for a new app

This repository is intented to be used as a template for new projects, i.e. you'd ordinarily make use of this repo like so:

	cd www/apps
	cake bake newproject -skel /path/to/this/repo

# Functionality

It's pretty basic, but includes:

* User management (register, forgotten password, administration)
* A contact form
* An admin panel
* example usage for each of the dependent plugins

Obviously, you can delete anything you don't want to use

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

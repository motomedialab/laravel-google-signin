# Effortless Google Sign-In for Laravel

![GitHub Actions](https://github.com/motomedialab/laravel-google-signin/actions/workflows/tests.yaml/badge.svg)

Seamlessly integrate Google OAuth2 Single Sign-On into your Laravel application with this streamlined package.
Born out of the need to efficiently implement Google OAuth2 authentication across multiple projects, this package
leverages Laravel's [Socialite](https://laravel.com/docs/11.x/socialite) under the hood,
adhering to best practices while simplifying the setup process. It bundles the necessary components, controllers, 
and routes for an effortless implementation.

## Installation

Install via Composer:

```bash
composer require motomedialab/laravel-google-signin
```
The package will auto-register. Next, add your Google Client ID and Secret to your `.env` file (see below for instructions
if you haven't set these up yet).

```text
GOOGLE_OAUTH_CLIENT_ID=your-client-id
GOOGLE_OAUTH_CLIENT_SECRET=your-client-secret
```

## Using the "Sign in with Google" button

![Sign in with Google](previews/button.png)

This package includes a ready-to-use "Sign in with Google" button. You can include it in your views as a blade component:

```blade
<x-google-signin::button />
```

For further styling, publish the button view to your project:

```bash
php artisan vendor:publish --tag=views-google-signin
```

That's it! You've successfully added Google SSO to your Laravel project.
If you haven't already, you'll need to obtain your Google Client ID and Secret from the Google Developer Console.


### Getting your Google Client ID and Secret

1. Visit the [Google Developer Console](https://console.developers.google.com/)
2. Create a new project or select an existing one
3. Navigate to the "Credentials" tab
4. Click the "Create Credentials" button and choose "OAuth client ID".
5. Select "Web application" as the application type
6. Add the URL to your callback route to the "Authorized redirect URIs" list
   1. you can find this by running `php artisan route:list --name=google-signin.store`
7. Click "Create" to generate your Client ID and Secret
8. Copy the generated ID and secret to your `.env` file as per [Configuration](#installation)

### Further customisation

To tailor the package's behavior further, such as modifying the login process, publish the
configuration file and override the default settings:

```text
php artisan vendor:publish --tag=config-google-signin
```

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email technical@motocom.co.uk instead of using the issue tracker.

### License

This package is licensed under the MIT License. See the [LICENSE](LICENSE.md) file for more information.

### Need help with your next project?

This plugin is maintained and developed by [MotoMediaLab](https://www.motomedialab.com), a full-service
agency based in the UK. Contact us for assistance with your next project!

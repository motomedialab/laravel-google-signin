# Laravel Google SignIn

![GitHub Actions](https://github.com/motomedialab/laravel-google-signin/actions/workflows/main.yml/badge.svg)

This package provides a simple way to authenticate users with Google Sign-In in your Laravel application.
It uses Laravel's Socialite package to handle the oAuth flow and conforming to best authentication standards.

![Sign in with Google](previews/button.png)

This package was born from a need to quickly and easily implement Google oAuth2 authentication across multiple projects.

## Installation

You can install the package via composer:

```bash
composer require motomedialab/laravel-google-signin
```

You should then publish the views - this ensures the TailwindCSS styles are available to you, and allows you to customise
the default button

```bash
php artisan vendor:publish --tag=views-google-signin
```

The package will automatically register everything it needs itself.

## Configuration

You only need to provide your Google Client ID and Client Secret for your oAuth2 screens - a how-to is provided below.

```text
GOOGLE_OAUTH_CLIENT_ID=your-client-id
GOOGLE_OAUTH_CLIENT_SECRET=your-client-secret
```

## Outputting the Sign in with Google button

You can use the default button within your project simply by calling the component:

```blade
<x-google-signin::button />
```

## Getting your Google Client ID and Secret

To get your Google Client ID and Secret, you need to create a new project in the Google Developer Console.

1. Go to the [Google Developer Console](https://console.developers.google.com/)
2. Create a new project (or utilise an existing one)
3. Go to the "Credentials" tab
4. Create a new "OAuth client ID" by pressing the 'Create Credentials' button
5. Choose "Web application" as the application type
6. Add your domain to the "Authorized JavaScript origins" list
7. Add the URL to your callback route to the "Authorized redirect URIs" list
   1. you can find this by running `php artisan route:list --name=google-signing.store`
8. Copy the Client ID and Secret to your `.env` file

## Customisation

If you'd like to customise the package options, such as changing the login mechanism, you can do so by publishing
the configuration file and overriding the default settings.

You can publish the configuration file by running:

```text
php artisan vendor:publish --tag=config-google-signin
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email chris@motocom.co.uk instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

# stickyeyes-localtunnel-formatter

A WordPress plugin to be used in partnership with our WordPress framework to enable ngrok URLs to share local WordPress instances.

## Step One: Install ‘Stickyeyes Localtunnel Formatter’ Plugin
Firstly install the plugin into the site, there is no configuration required or any settings pages so is nice and easy.

## Step Two: Add Snippet to wp-config.php
If you are using the new framework with seperated wp-config files, then just add this into the local version that you are wanting to share. There won’t be any errors if it is missing from your active wp-config, the plugin just won’t actually do anything till you do. If there is only a single wp-config then you can still add it as it won’t affect production.

```php
if(strpos($_SERVER['HTTP_X_ORIGINAL_HOST'], 'ngrok') !== FALSE) {
   if(
	isset($_SERVER['HTTP_X_ORIGINAL_HOST']) && 
	$_SERVER['HTTP_X_ORIGINAL_HOST'] === "https"
   ) {
       $server_proto = 'https://';
   } else {
       $server_proto = 'http://';
   }
   define('WP_SITEURL', $server_proto . $_SERVER['HTTP_HOST']);
   define('WP_HOME', $server_proto . $_SERVER['HTTP_HOST']);
   define('LOCALTUNNEL_ACTIVE', true);
}

```

What this will do is when it detects that you are accessing the site through an ngrok URL it will define the constants of WP_SITEURL and WP_HOME with the ngrok accesses URL, that way it can be dynamic as the URLs will change each time you spin one up. It will also define a constant to tell the plugin that the site is accessed through a localtunnel and to do its thing.

## Step Three: Start the ngrok server
The steps up till this point will only need to be done once, this final step however you will need to do each time you want to share a site.

If you have followed the ngrok suggested setup of placing the file in your home directory then you will just need to run the following command, replacing the URL with your local URL and if needed the port number too (MAMP tends to default to 8888).

```bash
~/ngrok http -host-header=sitename.localhost 8888
```

When you do this you should be presented with the ngrok response in your terminal. The URLs will appear after a few seconds when the connection is successful.

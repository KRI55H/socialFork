# SocialFork
![Packagist Version](https://img.shields.io/packagist/v/kri55h/socialfork.svg)
![Latest Version](https://img.shields.io/github/v/release/kri55h/socialfork)
![Packagist Downloads](https://img.shields.io/packagist/dt/kri55h/socialfork)
![PHP Version](https://img.shields.io/badge/PHP-^8.0-mediumslateblue)
![License](https://img.shields.io/github/license/KRI55H/socialFork)


### Installation Requirement
You have to download [yt-dlp](https://github.com/yt-dlp/yt-dlp#installation) in your command line.

### Installation

```bash
composer require kri55h/socialfork
```

## Usage
Here's an example demonstrating how to use the `RedditSaver` class from this package:
```php
use kri55h\redditsaver\RedditSaver;

try {
    $reddit = new RedditSaver();
    $reddit->setPostURL('<reddit_post_url>');
    $videoSaved = $reddit->saveVIDEO();

    if ($videoSaved) {
        // Video saved successfully
        return 'Video saved!';
    } else {
        // Handle if video saving failed
        return 'Failed to save video.';
    }
} catch (Exception $e) {
    // Handle any exceptions or errors that occurred during the process
    return 'An error occurred: ' . $e->getMessage();
}
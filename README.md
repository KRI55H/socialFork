# SocialFork
![Packagist Version](https://img.shields.io/packagist/v/kri55h/socialfork.svg)
![Latest Version](https://img.shields.io/github/v/release/kri55h/socialfork)
![Packagist Downloads](https://img.shields.io/packagist/dt/kri55h/socialfork)
![PHP Version](https://img.shields.io/badge/PHP-^8.0-mediumslateblue)
![License](https://img.shields.io/github/license/KRI55H/socialFork)


## Prerequisites

Before using Social Fork, make sure you have the following dependencies installed on your system:

- [ffmpeg](https://ffmpeg.org/download.html)
- [yt-dlp](https://github.com/yt-dlp/yt-dlp)

## Installation

Follow the steps below to install the required dependencies:

### Installing ffmpeg

1. **Windows:**
    - Visit the [official ffmpeg download page](https://ffmpeg.org/download.html).
    - Follow the instructions to download and install the executable.

2. **macOS:**
    - Install Homebrew if you haven't already by following the instructions on [Homebrew's website](https://brew.sh/).
    - Open a terminal and run the following command:
      ```bash
      brew install ffmpeg
      ```

3. **Linux (Debian/Ubuntu):**
    - Open a terminal and run the following command:
      ```bash
      sudo apt-get update
      sudo apt-get install ffmpeg
      ```

### Installing yt-dlp

1. **Windows, macOS, Linux:**
    - Open a terminal and run the following command:
      ```bash
      pip install -U yt-dlp
      ```

   If you don't have `pip` installed, you can get it by following the instructions [here](https://pip.pypa.io/en/stable/installation/).



## Usage

Now that you have the prerequisites installed, you can proceed to use Social Fork.


### 1. Install Social Fork via Composer

Run the following command in your project's root directory:

```bash
composer require kri55h/socialfork
```

### 2. Use Social Fork in your code

```php
use Kri55h\SocialFork;

try {
    // Instantiate SocialFork
    $socialFork = new SocialFork();

    // Set the URL of the post you want to download
    $socialFork->setUrl('<social_media_post_url>');

    // Set the path where you want to store the downloaded video
    $socialFork->setDownloadPath('<path_to_store_video>');

    // Set the desired name (without extension) for the downloaded video
    $socialFork->setName('<name_without_extension>');

    // Trigger the download process
    $videoSaved = $socialFork->download();

    if ($videoSaved) {
        return 'Video saved!';
    } else {
        return 'Failed to save video.';
    }
} catch (Exception $e) {
    // Handle any exceptions or errors that occurred during the process
    return 'An error occurred: ' . $e->getMessage();
}
```


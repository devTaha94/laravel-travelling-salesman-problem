# Laravel file uploader (Multipart & Base64)
## Installation

You can install the package via [Composer](https://getcomposer.org).

```bash
composer require ahmedtaha/laravel-file-uploader
```

## Usage

- To upload both [ Multipart - Base64  ] files .

```php
use Ahmedtaha\FileUploader\Services\Concrete\FileUploader;

    // path example : 'storage/images/users'
    
    // width and height are optional 
    
    $filename =  FileUploader::getInstance()
                 ->setParams($file,$path,$width,$height)
                 ->upload();
```


#Follow me 
#
[<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/github.svg' alt='github' height='40'>](https://github.com/https://gitlab.com/devTaha)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/linkedin.svg' alt='linkedin' height='40'>](https://www.linkedin.com/in/https://www.linkedin.com/in/devahmed94//)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/facebook.svg' alt='facebook' height='40'>](https://www.facebook.com/https://www.facebook.com/engahmedtaha94/)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/twitter.svg' alt='twitter' height='40'>](https://twitter.com/https://twitter.com/a7med_sh3ish3)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/stackoverflow.svg' alt='stackoverflow' height='40'>](https://stackoverflow.com/users/https://stackoverflow.com/users/6555104/ahmed-taha)  
#

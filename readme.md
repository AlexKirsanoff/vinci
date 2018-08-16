### Simple implementation of Vinci Api

Transform your photos using of neural networks from Vinci

Before:

![before](img/photo.jpg)

After:

![after](img/after.jpg)   

***

Install via composer:

    composer require alexkirsanoff/vinci

***
    
Get list of filters

    $filters = Vinci::filters();
    
Get id of filter, for example a mystical filter 
    
    $filterId = $filters['mystic'];
    
Upload image for getting file id
    
    $image = file_get_contents(__DIR__ . '/image.jpeg');
    $fileId = Vinci::upload($image);
    
    
Convert image to art using file id and filter id
    
    $art = Vinci::download($fileId, $filterId);
    
    // display given art
    $art = imagecreatefromstring($art);
    header('Content-type: image/jpeg');
    imagejpeg($art);
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

Create new object

    $vinci = new Vinci();
    
Get list of filters

    $filters = $vinci->filters();
    
Get id of filter, for example a mystical filter 
    
    $filterId = $filters['mystic'];
    
Upload image and get file id
    
    $image = file_get_contents(__DIR__ . '/image.jpeg');
    $fileId = $vinci->upload($image);
    
    
Convert image to art using file id and filter id
    
    $art = $vinci->download($fileId, $filterId);
    
    // display given art
    $art = imagecreatefromstring($art);
    header('Content-type: image/jpeg');
    imagejpeg($art);
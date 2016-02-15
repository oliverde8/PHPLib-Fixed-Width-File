# PHPLib-Fixed-Width-File
Allows easy Read(not yet) and write of fixed width file. 

[![Latest Stable Version](https://poser.pugx.org/oliverde8/fixed-width-file/v/stable)](https://packagist.org/packages/oliverde8/fixed-width-file) [![Total Downloads](https://poser.pugx.org/oliverde8/fixed-width-file/downloads)](https://packagist.org/packages/oliverde8/fixed-width-file) [![Latest Unstable Version](https://poser.pugx.org/oliverde8/fixed-width-file/v/unstable)](https://packagist.org/packages/oliverde8/fixed-width-file) [![License](https://poser.pugx.org/oliverde8/fixed-width-file/license)](https://packagist.org/packages/oliverde8/fixed-width-file)

They are not nice, they are not easy to read but sometimes you just need them. 

## Howto

Firs let's create our file :
```
$writer = new Writer('/tmp/file.txt', ' ', STR_PAD_LEFT);
```
First parameter is the name of the file to write
Then we have the padding character, by default it is empty.
Last we have the direction to pad. right or left. 

Now we will declare our columns : 
```
$writer->getHeader()
    ->addColumn(4, 'year')
    ->addColumn(2, 'month')
    ->addColumn(2, 'day')
    ->addColumn(20, 'name')
    ->addColumn(100, 'description')
```

Once all this is done we can add data : 
```
// First line
$data = array();
$data['year'] = 2016;
$data['month'] = 02;
$data['day'] = 15;
$data['description'] = "This is a description" ;
$writer->writeLine($data);

// second line
$data = array();
$data['year'] = 2016;
$data['month'] = 02;
$data['day'] = 1;
$data['description'] = "This is a description2" ;
$writer->writeLine($data);
```

End finish the write 
```
$writer->terminate():
```

This will create a file looking like this : 
```
20160215This is a description
201602 1This is a description2
```

## Known Issues
 - None
 
The library will write every line as it comes, it was built for handling huge amounts of data and therfore doesen't have a mode where it can write everything at once at the end. 

## Todo 
- Support reading : The same way the files are written we can read them once we have the necessary header informations. 

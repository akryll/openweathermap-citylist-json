# openweathermap-citylist-json
### Usage
* Download fresh City List from [here](http://openweathermap.org/help/city_list.txt "OWM CityList").
* Place it to script folder.
* Run script in CLI! 
Ex.: 
```
php Generator.php <arg>
```
#### Arguments
* full - For full city list generation. Warning! Big JSON file! < 6Mb
Ex.:
```
php Generator.php full
```
* bycc - Devide list by Country Code in byCC folder.
Ex.:
```
php Generator.php bycc
```
* <country code> - Generate only One country. 
Ex.:
```
php Generator.php RU
```


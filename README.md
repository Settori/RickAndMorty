# Rick & Morty Search

## Opis

Projekt strony internetowej, służącej do wyszukiwania i oceniania postaci z kreskówki "Rick & Morty".

Strona korzysta z API proponowanego w mailu [rickandmortyapi.com](https://rickandmortyapi.com)

Projekt napisany z użyciem technologii:
- PHP
- MySQL
- AJAX
- JavaScript / jQuery
- HTML
- CSS


## Mapa plików
Pomijam opis plików takich jak `index.php`, czy katalogi `css`, `js`, z oczywistych względów :)
- `class.php` - Plik zawierający klasę z główną funkcjonalnością (łączenie z bazą danych, wyszukiwanie itp.)
- `main.css` - Główny plik CSS
- `main.js` - Główny plik JavaScript
- katalog `components` - zawiera dwa katalogi z głównymi komponentami
  - katalog `ajax` - zawiera pliki niezbędne do wywoływania asynchronicznych funkcji
  - katalog `modules` - zawiera pliki z sekcjami strony. Takie jak navbar, czy formularze

## Instalacja

Pliki należy skopiować na serwer. Następnie do bazy danych MySQL należy zaimportować plik `zadanie.sql`.

W pliku `class.php` należy zmienić dane potrzebne do nawiązania połączenia z bazą danych.

```php
private $db_host = "";   //Adres serwera
private $db_user = "";   //Nazwa użytkownika
private $db_pass = "";   //Hasło
private $db_name = "";   //Nazwa bazy danych
```
Do korzystania ze strony należy założyć nowe konto.


## Stworzone przez
Szymon Walosik
# BHS Konstverket – bhs-konstverket.se

Statisk webbplats om Bertil Herlow-Svensson (1929–2012) och monografin om honom. Den ersätter
WordPress-installationen på one.com och behöver ingen databas, inga tillägg och inga uppdateringar.
Layout, texter och bilder är hämtade från den tidigare WordPress-sajten.

## Filer

| Fil | Innehåll |
|---|---|
| `index.html` | Startsidan: hero med skrivmaskinsrubrik, konkretisttext, citat, bokpuff |
| `bestall/index.html` | Beställningssidan med formulär (samma adress som förut: `/bestall/`) |
| `bestall.php` | Tar emot beställningen, mejlar den till goddag@bhs-konstverket.se och skickar en bekräftelse till kunden |
| `tack/index.html` | Tacksidan efter beställning (`/tack/`) |
| `404.html` | Visas för adresser som inte finns |
| `.htaccess` | HTTPS, 404-sida, cachning, omdirigering av gamla WordPress-adresser |
| `css/style.css` | All formgivning. Färger och typsnitt finns överst i filen (`--accent` är den rosa färgen) |
| `js/main.js` | Skrivmaskinseffekten, summan i beställningsformuläret, felmeddelanden |
| `images/`, `fonts/` | Bilder och typsnittet Raleway, som ligger på den egna servern (inga anrop till Google) |

### Vanliga ändringar
- **Pris:** ändra `595` i `bestall/index.html` (två ställen), `js/main.js` och `bestall.php` (`$price`).
- **E-postadress för beställningar:** `$to` och `$from` överst i `bestall.php`.
- **Orden i rubriken** ("Påstå. Förmå. Begå. …"): attributet `data-words` i `index.html`.
- Sidhuvud och sidfot finns i varje HTML-fil. Ändringar där görs i alla fyra filerna.

## Publicera på one.com

1. **Ta säkerhetskopia av WordPress.** Logga in på one.com, öppna *Filhanteraren* och ladda ner allt
   i webbroten (`/`). Exportera också databasen i *phpMyAdmin*.
2. Skapa en mapp `gammal-wordpress` och flytta dit alla befintliga filer och mappar i webbroten
   (`wp-admin`, `wp-content`, `wp-includes`, `index.php`, `.htaccess`, `wp-config.php` och så vidare).
3. Ladda upp **innehållet** i det här repot till webbroten, via Filhanteraren eller med SFTP, till
   exempel FileZilla. Glöm inte den dolda filen `.htaccess`. Mappen `.git` och `README.md` behövs inte.
4. Testa startsidan, `/bestall/` och gör en testbeställning till din egen e-postadress.
5. När allt fungerar kan du ta bort `gammal-wordpress/` och WordPress-databasen.

> Beställningsmejlen skickas med one.com:s PHP-funktion `mail()`. Avsändaradressen (`$from`) måste
> vara en adress på domänen bhs-konstverket.se, annars kan mejlen hamna i skräpposten.

## Testa lokalt

```sh
php -S localhost:8000
```

Öppna sedan http://localhost:8000. Formuläret går igenom valideringen, men mejl skickas bara på servern.

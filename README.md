# Kvalifikācijas darbs – Game to Top

Šis ir Laravel projekts, kurā var apskatīt videospēles, meklēt tās pēc nosaukuma, izmantot filtrus un nejauši izvēlēties spēli. Projekts ir paredzēts lietotājiem, kuri vēlas vieglāk atrast jaunas videospēles un izvēlēties, ko spēlēt. Spēļu informācijas iegūšanai projektā tiek izmantots RAWG Video Games Database API. Projektā ir arī spēļu detalizētās informācijas lapas un turnīra režīms, kurā var izvēlēties spēles savstarpējai sacensībai.

## Kā es plānoju šo projektu palaist lokāli

Es izmantoju Laragon, Cmder termināli un MySQL datubāzi. Projektu var palaist lokāli, izmantojot Laravel izstrādes serveri.

Projektam nepieciešams PHP 8.3 vai jaunāks, Composer, kā arī Node.js un npm, lai uzstādītu un palaistu projekta CSS un JavaScript resursus.

Sākumā ievietoju projektu Laragon **www** mapē un atveru termināli projekta mapē:

```bash
cd C:\laragon\www\Kvalifikacijas_darbsIPa23Markus
```

Pēc tam uzstādu PHP atkarības:

```bash
composer install
```

Lai atvērtu projektu Visual Studio Code, izmantoju komandu:

```bash
code .
```

Lai uzstādītu JavaScript atkarības, izmantoju:

```bash
npm install
```

### Vides konfigurācija

Pēc projekta atvēršanas izveidoju savu **.env** failu no parauga:

```bash
copy .env.example .env
```

Projektā izmantoju MySQL datubāzi ar nosaukumu **kvalifikacijas_darbs**. Datubāzes iestatījumus norādu failā **.env**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kvalifikacijas_darbs
DB_USERNAME=root
DB_PASSWORD=
```

Pēc tam izveidoju Laravel lietotnes atslēgu:

```bash
php artisan key:generate
```

### Datubāzes migrācijas

Lai izveidotu nepieciešamās datubāzes tabulas, palaižu migrācijas:

```bash
php artisan migrate
```

Šī komanda izveido tabulas, kas nepieciešamas projekta darbībai, piemēram, lietotāju, spēļu un ar spēlēm saistīto datu glabāšanai.

Ja projektā ir izveidoti sākuma datu ievietošanas skripti jeb seeders, tos var palaist ar komandu:

```bash
php artisan db:seed
```

Komandu izmantoju tikai tad, ja projektā ir nepieciešami un konfigurēti sākuma dati.

### RAWG API konfigurācija

Game to Top izmanto RAWG Video Games Database API, lai iegūtu informāciju par videospēlēm.

Lai izmantotu API, nepieciešams iegūt savu API atslēgu RAWG vietnē: https://rawg.io/apidocs.

Pēc API atslēgas iegūšanas to pievienoju projekta saknes mapē esošajam **.env** failam:

```env
4f3147ad31ea434097f36f8e663a2f15
```

Vērtību `your_rawg_api_key_here` aizstāju ar savu API atslēgu. Lai šī konfigurācija darbotos, projekta kodam jāizmanto tieši šāds vides mainīgā nosaukums.

API atslēgu nedrīkst ievietot publiskajā GitHub repozitorijā. Failā **.env.example** atstāju tikai tukšu mainīgā vērtību:

```env
RAWG_API_KEY=
```

### Projekta resursu palaišana

Lai palaistu projekta priekšgala resursus izstrādes režīmā, izmantoju:

```bash
npm run dev
```

Šī komanda darbojas izstrādes laikā, tāpēc terminālim jāpaliek atvērtam.

### Palaišana pārlūkā

Terminālī palaižu Laravel izstrādes serveri:

```bash
php artisan serve
```

Pēc noklusējuma projektu atveru pārlūkā šajā adresē:

http://127.0.0.1:8000/

Ja nepieciešams, Laravel serveri un `npm run dev` palaižu atsevišķos termināļos.

### Projekta galvenās funkcijas

- Videospēļu kataloga apskate.
- Spēļu meklēšana pēc nosaukuma.
- Spēļu filtrēšana pēc pieejamajiem kritērijiem.
- Nejaušas videospēles izvēle.
- Detalizētas informācijas apskate par izvēlēto spēli.
- Spēļu datu iegūšana no RAWG API.
- Turnīra režīms, kurā var izvēlēties spēles savstarpējai sacensībai.

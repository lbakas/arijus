Pasiklonavus projektą eiti pirmiausia į backend

    cd backend

Suinstaliuoti dependencies

    composer install

Paleisti MySQL ir sukurti duomenų bazę, kurią įrašyti į .env failą padarius .env.example kopiją

    php artisan migrate

Sugeneruoti aplikacijos raktą

    php artisan key:generate

Paleisti serverį

    php artisan serve

Tada eiti į frontend naujame command lange

    cd frontend

Suinstaliuoti dependencies

    npm install

Paleisti serverį

    npm run dev

Įsitikinti, kad environment.js gerai nurodytas backendo url
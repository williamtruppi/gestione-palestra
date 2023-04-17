# Titolo del progetto

GESTIONE PALESTRA

## Funzionalità

- Crud Customer
- Crud Prenotazione Corso con controllo su validità abbonamento e raggiungimento numero massimo
- Api Controllo abbonamenti

## Tecnologie utilizzate

- Laravel
- MySQL
- Sanctum

## Requisiti

- PHP 7.4 o superiore
- MySQL
- ...

## Installazione

1. Clonare il repository
2. Installare le dipendenze con il comando `composer install`
3. Creare il file `.env` (utilizzando `.env.example` come riferimento) e configurare le variabili d'ambiente come necessario
4. Creare il database con il comando `php artisan migrate`
5. Avviare il server con il comando `php artisan serve`
6. Eseguire `php artisan db:seed` per popolare il database con i dati di prova.
7. Eseguire `php artisan serve` per avviare il server di sviluppo

## API

L'applicazione espone le seguenti API:

### GET /api/gym/customers

Restituisce la lista dei clienti registrati nell'applicazione.

#### Parametri

- `email` (opzionale): ricerca per email.
- `membership_type` (opzionale): restituisce gli abbonamenti di un determinato tipo (1- Base, 2 - Intermedio, 3 - Avanzato).
- `membership_duration` (opzionale): restituisce gli abbonamenti con una certa durata (1- Mensile, 3 - Trimestrale, 6 - Semestrale, 12 - Annuale).
- `membership_status` (opzionale): restituisce gli abbonamenti con un determinato status (0 - Non attivo, 1- Attivo, 2 - Scaduto, 3 - Sospeso, 4 - Interrotto).


#### Esempio di risposta

```json
{
    "data": [
        {
            "id": 1,
            "name": "Kimberly Ullrich",
            "email": "durward48@lakin.com",
            "phone": "1-601-209-8509",
            "membershipType": 2,
            "membershipDuration": 3,
            "membershipStatus": 4,
            "cardCode": "6619677"
        },
    ]
}
```

## Licenza

[MIT License](https://opensource.org/licenses/MIT)

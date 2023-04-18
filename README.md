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
5. Eseguire `php artisan db:seed` per popolare il database con i dati di prova.
6. Eseguire `php artisan serve` per avviare il server di sviluppo

## API

Accedere a `/setup` per poter recuperare il bearer token necessario per l'accesso all'API.
Di seguito le API esposte:

### GET /api/gym/customers

Restituisce la lista dei clienti registrati nell'applicazione.

#### Parametri

- `email` (opzionale): ricerca per email.
- `membership_type` (opzionale): restituisce gli abbonamenti di un determinato tipo (1- Base, 2 - Intermedio, 3 - Avanzato).
- `membership_duration` (opzionale): restituisce gli abbonamenti con una certa durata (1- Mensile, 3 - Trimestrale, 6 - Semestrale, 12 - Annuale).
- `membership_status` (opzionale): restituisce gli abbonamenti con un determinato status (0 - Non attivo, 1- Attivo, 2 - Scaduto, 3 - Sospeso, 4 - Interrotto).

#### Esempio di risposta
`http://127.0.0.1:8000/api/gym/customers?membership_duration=3&membership_type=3`
```json
{
    "data": [
        {
            "id": 5,
            "name": "Lane King",
            "email": "zschmidt@barrows.com",
            "phone": "+1.820.503.6679",
            "membershipType": 3,
            "membershipDuration": 3,
            "membershipStatus": 3,
            "cardCode": "325553619"
        },
        {
            "id": 7,
            "name": "Armand Monahan",
            "email": "eleannon@runte.com",
            "phone": "1-434-781-7436",
            "membershipType": 3,
            "membershipDuration": 3,
            "membershipStatus": 4,
            "cardCode": "114753877"
        }
    ]
}
```
### GET /api/gym/customers/checkabbonamenti

Effettua un controllo su tutti i clienti presenti e:
- se l'utente ha l'abbonamento scaduto, è previsto l'invio di una mail volta a ricordarglielo o a interrompere lo stesso qualora non fosse più richiesto.
- se l'utente ha l'abbonamento in scadenza, è previsto l'invio di una mail volta a ricordarglielo.

#### Parametri

Nessun parametro previsto.

#### Esempio di risposta

Messaggio di avvenuto invio con le relative anagrafiche.

### POST /api/gym/bookings

Api di inserimento della prenotazione. Viene effettuato un controllo in primis sulla validità dell'abbonamento del cliente e successivamente sulla capienza massima raggiunta per la lezione scelta.

#### Parametri

- `customer_id`: id del cliente.
- `lesson_id` : id della lezione.

#### Esempio di invio
```json
{
    "customer_id": 5,
    "lesson_id": 4
}
```

#### Esempio di risposta

Messaggio di avvenuta conferma, o meno, della prenotazione.

## Licenza

[MIT License](https://opensource.org/licenses/MIT)

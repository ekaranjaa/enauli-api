# E-Nauli API

## Setup
[Laravel](https://laravel.com/docs/9.x/installation)

[Laravel Mail & MailHog](https://laravel.com/docs/9.x/mail)

## Authentication

Each user has a role that in their sacco apart from the `System Admin` who has access to all the resources. Roles available are

- System Admin - Has access to all resources
- Owner - Can own and administrate an sacco
- Official - Can administrate a sacco
- Operator - Can operate a vehicle

### Credentials

Admin

```bash
Phone: 07123456789
Password: password
```

Owner

```bash
Phone: 0787654321
Password: password
```

### Register

Endpoint

```bash
POST - http://enauli.loc/api/auth/register
```

Request body

```json5
{
    "name": "John Doe",
    "email": "john@example.com",
    "phone_number": "0712345678",
    "password": "password",
    "password_confirmation": "password"
}
```

Response body

```json5
{
    "message": "Account Created."
}
```

### Login

Endpoint

```bash
POST - http://enauli.loc/api/auth/login
```

Request body

```json5
{
    "phone_number": "0712345678",
    "password": "password"
}
```

Response body

```
1|4WiUKPBazHGGE4CMGVkTWGtekbfRXBrc9TWj9uTJ
```

### Change Password

Endpoint

```bash
POST - http://enauli.loc/api/auth/change-password
```

Request body

```json5
{
    "current_password": "password",
    "password": "123456",
    "password_confirmation": "123456"
}
```

Response body

```json5
{
    "message": "Password changed."
}
```

### Forgot Password

Endpoint

```bash
POST - http://enauli.loc/api/auth/forgot-password
```

Request body

```json5
{
    "email": "john@example.com"
}
```

Response body

```json5
{
    "message": "We have emailed your password reset link!"
}
```

### Reset Password

Endpoint

```bash
POST - http://enauli.loc/api/auth/reset-password
```

Request body

```json5
{
    "token": "uhwgheghwohegkkjbfbfaflishgsdhshgfoisduhsdiohgsiodh",
    "email": "john@example.com",
    "password": "123456"
}
```

Response body

```json5
{
    "message": "Your password has been reset!"
}
```

## Users

### Create & Update

Endpoint

```bash
POST - http://enauli.loc/api/users
PUT - http://enauli.loc/api/users/{id}
```

Request body

```json5
{
    "name": "John Doe",
    "email": "john@example.com",
    "phone_number": "0712345678"
}
```

Response body

```json5
{
    "message": "User created.",
    "resource": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone_number": "0712345678",
        "temp_password": "sdhbnarten", // Random string hashed as password
        'email_verified': false,
        'deactivated': false,
        "time_stamps": {
            "email_verified_at": null,
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### List & Show

Endpoint

```bash
GET - http://enauli.loc/api/users
GET - http://enauli.loc/api/users/{id}
```

Response body

```json5
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone_number": "0712345678",
        "temp_password": null,
        'email_verified': true,
        'deactivated': false,
        "time_stamps": {
            "email_verified_at": "2022-12-15 10:13:16",
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
]
```

### Deactivate

Endpoint

```bash
POST - http://enauli.loc/api/users/{id}/deactivate
```

Response body

```json5
{
    "message": "User deactivated.",
    "resource": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone_number": "0712345678",
        "temp_password": null,
        'email_verified': true,
        'deactivated': true,
        "time_stamps": {
            "email_verified_at": "2022-12-15 10:13:16",
            "deactivated_at": "2022-12-15 10:13:16",
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

## Sacco

### Create & Update

Endpoint

```bash
POST - http://enauli.loc/api/saccos
PUT - http://enauli.loc/api/saccos/{id}
```

Request body

```json5
{
    "owner_id": 2,
    "name": "Test Sacco"
}
```

Response body

```json5
{
    "message": "Sacco created.",
    "resource": {
        "id": 1,
        "name": "Test Sacco",
        "email": "john@example.com",
        'deactivated': false,
        "time_stamps": {
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### List & Show

Endpoint

```bash
GET - http://enauli.loc/api/saccos
GET - http://enauli.loc/api/saccos/{id}
```

Response body

```json5
[
    {
        "id": 1,
        "name": "Test Sacco",
        "email": "john@example.com",
        'deactivated': false,
        "time_stamps": {
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
]
```

### Deactivate

Endpoint

```bash
POST - http://enauli.loc/api/saccos/{id}/deactivate
```

Response body

```json5
{
    "message": "User deactivated.",
    "resource": {
        "id": 1,
        "name": "Test Sacco",
        "email": "john@example.com",
        'deactivated': false,
        "time_stamps": {
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### Sacco Users

Endpoint

```bash
GET - http://enauli.loc/api/saccos/{id}/users
```

Response body

```
Same as vehicles list response
```

### Sacco Stations

Endpoint

```bash
GET - http://enauli.loc/api/saccos/{id}/stations
```

Response body

```
Same as stations list response
```

### Sacco Vehicles

Endpoint

```bash
GET - http://enauli.loc/api/saccos/{id}/vehicles
```

Response body

```
Same as vehicles list response
```

### Sacco Charges

Endpoint

```bash
GET - http://enauli.loc/api/saccos/{id}/charges
```

Response body

```
Same as charges list response
```

## Stations

### Create & Update

Endpoint

```bash
POST - http://enauli.loc/api/stations
PUT - http://enauli.loc/api/stations/{id}
```

Request body

```json5
{
    "sacco_id": 2,
    "name": "Test Station",
    "location": "Nairobi"
}
```

Response body

```json5
{
    "message": "Sacco created.",
    "resource": {
        "id": 1,
        "name": "Test Sacco",
        "location": "Nairobi",
        'deactivated': false,
        "time_stamps": {
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### List & Show

Endpoint

```bash
GET - http://enauli.loc/api/stations
GET - http://enauli.loc/api/stations/{id}
```

Response body

```json5
[
    {
        "id": 1,
        "name": "Test Sacco",
        "location": "Nairobi",
        'deactivated': false,
        "time_stamps": {
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
]
```

### Deactivate

Endpoint

```bash
POST - http://enauli.loc/api/stations/{id}/deactivate
```

Response body

```json5
{
    "message": "User deactivated.",
    "resource": {
        "id": 1,
        "name": "Test Sacco",
        "location": "Nairobi",
        'deactivated': false,
        "time_stamps": {
            "deactivated_at": null,
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### Station Vehicles

Endpoint

```bash
GET - http://enauli.loc/api/stations/{id}/vehicles
```

Response body

```
Same as vehicles list response
```

## Vehicles

### Create & Update

Endpoint

```bash
POST - http://enauli.loc/api/vehicles
PUT - http://enauli.loc/api/vehicles/{id}
```

Request body

```json5
{
    "station_id": 2,
    "name": "Modern Coach",
    "model_name": "Mercedes",
    "model_year": 2011,
    "capacity": 20
}
```

Response body

```json5
{
    "message": "Sacco created.",
    "resource": {
        "id": 1,
        "name": "Modern Coach",
        "capacity": 20,
        "model": {
            "name": "Mercedes",
            "year": 2011,
        },
        "time_stamps": {
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### List & Show

Endpoint

```bash
GET - http://enauli.loc/api/vehicles
GET - http://enauli.loc/api/vehicles/{id}
```

Response body

```json5
[
    {
        "id": 1,
        "name": "Modern Coach",
        "capacity": 20,
        "model": {
            "name": "Mercedes",
            "year": 2011,
        },
        "time_stamps": {
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
]
```

### Station Operators

Endpoint

```bash
GET - http://enauli.loc/api/vehicles/{id}/operators
```

Response body

```
Same as users list response
```

## Charges

### Create & Update

Endpoint

```bash
POST - http://enauli.loc/api/charges
PUT - http://enauli.loc/api/charges/{id}
```

Request body

```json5
{
    "sacco_id": 2,
    "label": "Maintenance",
    "cost": 8000
}
```

Response body

```json5
{
    "message": "Sacco created.",
    "resource": {
        "id": 1,
        "label": "Maintenance",
        "cost": 8000,
        "time_stamps": {
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
}
```

### List & Show

Endpoint

```bash
GET - http://enauli.loc/api/charges
GET - http://enauli.loc/api/charges/{id}
```

Response body

```json5
[
    {
        "id": 1,
        "label": "Maintenance",
        "cost": 8000,
        "time_stamps": {
            "created_at": "2022-12-15 10:13:16",
            "updated_at": "2022-12-15 10:13:16"
        }
    }
]
```

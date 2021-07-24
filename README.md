
# Задание:
Реализовать колбэк для платежного шлюза, предусмотреть обновление статуса заказа при удачной и неудачной оплате и уведомление пользователя об этом.
В случае неудачи - редирект на /sorry страницу с сообщением и деталями транзакции.
В случае успеха -  редирект на /thank-you  страницу с сообщением об успешной оплате.
На основную страницу добавить 2 кнопки (Success Request / Fail Request), по нажатию на которые, отправляется ajax запрос (тело запроса, json в ТЗ) на callback, после - редирект на соответствествующую страницу.

# Контекст:

Framework: Laravel
DB: MySQL

Models:
Order ( fields: id, status methods: update(data,id),  )

Controllers:
ApiController (method: callback()) // как раз тот метод, который нужно реализовать

Request Payload from payment gateway callback:

{
    "pay_form": {
        "token": "xxx",
        "design_name": "des1"
    },
    "transactions": {
        "12345-7891234567": {
            "id": "12345-7891234567",
            "operation": "pay",
            "status": "fail",
            "descriptor": "FAKE_PSP",
            "amount": 2345,
            "currency": "USD",
            "fee": {
                "amount": 0,
                "currency": "USD"
            },
            "card": {
                "bank": "CITIZENS STATE BANK",
            }
    }
    },
    "error": {
        "code": "6.01",
        "messages": [
            "Unknown decline code"
        ],
        "recommended_message_for_user": "Unknown decline code"
    },
    "order": {
        "order_id": "12345-7891234567",
        "status": "declined",
        "amount": 2345,
        "refunded_amount": 0,
        "currency": "USD",
        "marketing_amount": 2345,
        "marketing_currency": "USD",
        "processing_amount": 2345,
        "processing_currency": "USD",
        "descriptor": "FAKE_PSP",
        "fraudulent": false,
        "total_fee_amount": 0,
        "fee_currency": "USD"
    },
    "transaction": {
        "id": "12345-7891234567",
        "operation": "pay",
        "status": "fail"
    }
}

View -  сделать самому на ваше усмотрение.

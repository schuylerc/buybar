# buybar
Your connected bar experience™

## endpoints

POST `/api/v1/keys`
- Generates new keys based on username and password
- Required Fields: username, password, device
GET `/api/v1/keys`
- lists available keys
- Required Fields: username, password, device

DELETE `/api/v1/keys/*ID*`
- deletes a key by ID
- Required Fields: *ID*

GET `/api/v1/menu_items`
- returns a full list of menu items

GET `/api/v1/orders`
- returns a full list of orders

GET `/api/v1/sessions`
- returns a full list of sessions




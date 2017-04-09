# buybar
Your connected bar experience™

## endpoints

_API Server is at `http://ec2-54-236-35-76.compute-1.amazonaws.com/`_

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

POST `/api/v1/orders`
- creates a new order
- Required Fields: item, session

POST `/api/v1/sessions`
- creates a new session by accepting parsed ID info

DELETE `/api/v1/sessions`
- removes the session from the system

POST `/api/v1/locate_session`
- finds the session the user started at check in
- Required Fields: id_code
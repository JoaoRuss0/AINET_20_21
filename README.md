# Users and Functionalities

## Anonymous Users

- Consult and filter the catalog ✓
- Add, remove and alter shopping cart ✓
- Register a user account ✓

## Clients

- Everything an ***Anonymous User*** can do (except register a new account) ✓
- View and alter account information ✓
- Change account password ✓
- Confirm shopping cart/purchase and create orders ✓
- Consult order history (including **PDF** invoice) ✓ (not invoice)
- Manage own T-shirt stamps ✓
- Receive an email when an order is:
  - Created ("**Pending**") ✓
  - Canceled ("**Canceled**") ✓
  - Shipped ("**Closed**")
    - Invoice should be sent to the client

## Workers

- Change account password x
- Manage **Orders** ("**Pending**" and "**Paid**"): ✓
  - Consult
  - See details
- Change **Order's** state from: ✓
  - "**Pending**" to "**Paid**"
  - "**Paid**" to "**Closed**"

## Administrators

- View and alter account information ✓
- Change account password ✓
- Manage ***Worker*** and ***Administrator*** accounts: ✓
  - Consult
  - Filter
  - Create
  - Alter
  - Block
  - Remove
- Manage ***Client*** accounts:  ✓
  - Filter
  - Block
  - Delete(Soft Deletes)
- Manage **Orders** (independently of state): ✓
  - Consult
  - Filter
  - See details (*PDF* not yet done)
- Declare **Orders** as: ✓
  - "**Canceled**"
  - "**Paid**"
  - "**Closed**"
- Manage **Categories** and the **Stamp Catalog** ✓
- Set prices ✓
- Manage color list ✓
- Visualize business info (Example: tables, graphs, etc ...) x

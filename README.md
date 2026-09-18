# Q4Pay (SandboxPay) - Digital Payment Infrastructure

Welcome to the **Q4Pay** repository. This is a comprehensive, enterprise-grade financial technology application built with Laravel and Filament, designed to empower merchants, vendors, and platform administrators with seamless payment gateways, virtual accounts, and robust operational oversight.

## 🚀 Core Features

### 1. Merchant & Vendor Portals
Dedicated dashboard interfaces tailored for both Merchants and Vendors:
- **Wallet & Ledger:** Track account balances, transactions, and real-time ledger histories.
- **Virtual Accounts:** Dynamic and static virtual account generation powered by integrations with **9PSB** and **Monnify**.
- **Payment Links:** Allow businesses to easily generate payment links and receive funds globally.
- **Sub-Agents & Teams:** Powerful Role-Based Access Control (RBAC) to allow merchants to invite and manage team members and sub-agents.

### 2. Administrator "God Eye" Control Center
The platform features an advanced administration panel built using **Filament v3**. The pinnacle of this administration area is the **God's Eye Dashboard**, which gives super-admins complete oversight.
- **Irene's Insights AI:** An intelligent, widget-driven summary system named "Irene". Irene monitors the platform in real-time and provides interactive alerts for:
  - **Suspicious Activity:** Detects unusual withdrawal volumes or rapid failed logins.
  - **System Health:** Monitors the uptime and API connectivity of 3rd party providers (9PSB/Monnify).
  - **Escrow Disputes:** Flags unresolved or aged escrow transaction disputes for immediate administrator action.
  - **Pending Approvals:** Highlights pending KYC submissions and unverified merchants.

### 3. Compliance & Security
- **KYC Verification:** Built-in Know Your Customer workflows to verify merchants before they can transact.
- **Audit Logs:** Comprehensive action tracking. Every sensitive action taken by administrators or merchants is recorded for compliance.
- **Chargebacks & Disputes:** Escrow and dispute management system to protect buyers and sellers.

## 🛠 Tech Stack

- **Framework:** Laravel 11
- **Admin Panel:** Filament PHP v3
- **Frontend (TALL Stack):** Tailwind CSS, Alpine.js, Laravel Livewire
- **Database:** MySQL
- **Integrations:** 9PSB API, Monnify API (Virtual Accounts & Collections)

## 📦 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/alagaddonjuan/q4pay.git
   cd q4pay
   ```

2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM Dependencies:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup:**
   Copy the example environment file and configure your database and API keys:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application:**
   ```bash
   php artisan serve
   ```

## 🛡 Security Vulnerabilities
If you discover a security vulnerability within Q4Pay, please contact the lead developer directly. All security vulnerabilities will be promptly addressed.

## 📄 License
This project is proprietary software. All rights reserved.

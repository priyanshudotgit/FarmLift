# FarmLift 🚜

**Smart Logistics Pooling for Farmers**

FarmLift is a B2B SaaS marketplace built to solve agricultural logistics. It connects farmers with truck drivers who have available payload space on their routes. By sharing space, farmers split costs and drivers maximize their earnings.

---

## 🌟 Features

- **Role-Based Access Control:** Separate registration and dashboards for Farmers and Drivers.
- **Geo-Spatial Search:** Farmers can search for trips within a 30km radius of their location using MongoDB's `$centerSphere` and GeoJSON queries.
- **Atomic Bookings:** A robust concurrency-safe booking engine that guarantees no race conditions when reserving payload capacity.
- **Trip Status Workflows:** Track shipments from `Scheduled` -> `Active` -> `Completed` and bookings from `Pending` -> `Confirmed` -> `PickedUp` -> `Delivered`.
- **Real-time UI:** Built with Laravel 11, Tailwind CSS (v4), and Alpine.js for a snappy, app-like feel.

---

## 🏗 Architecture

- **Backend:** Laravel 11. Custom Service classes (e.g., `TripService`, `SearchService`) handle core business logic.
- **Database:** MongoDB Atlas via the official `mongodb/laravel-mongodb` driver. We use MongoDB specifically for its rich GeoJSON query capabilities and atomic `$inc` operators.
- **Frontend:** Blade templates styling with Tailwind CSS v4. Interactivity (modals, search fetching, toggles) is handled seamlessly by Alpine.js.
- **State Flow:** Controllers orchestrate Requests -> Services -> MongoDB Models. Events & Listeners fire asynchronously to dispatch Notification Jobs to a Queue.

---

## 📸 Screens Overview

1. **Welcome Landing:** A modern bento-grid layout explaining the value proposition and core features.
2. **Dynamic Auth:** A toggleable login/registration screen that adapts dynamically to the selected role (Farmer/Driver).
3. **Farmer Dashboard:** A split-view interface allowing farmers to perform radial geo-searches for trucks, view capacity progress bars, and track active bookings.
4. **Driver Dashboard:** A comprehensive list of created trips, complete with expandable load manifests showing all booked cargo and interactive status selectors.
5. **Create Trip:** A streamlined form for drivers to set waypoints, capacity, and rate-per-ton.

---

## 🚀 Setup Steps

1. **Clone the repository.**
2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```
3. **Install Frontend Dependencies:**
   ```bash
   npm install
   ```
4. **Environment Setup:**
   Copy `.env.example` to `.env` (or use the provided setup) and configure your MongoDB Atlas connection:
   ```env
   DB_CONNECTION=mongodb
   DB_HOST=your_cluster.mongodb.net
   DB_PORT=27017
   DB_DATABASE=farmlift
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   DB_OPTIONS="replicaSet=atlas-xxxx&authSource=admin&retryWrites=true&w=majority"
   ```
5. **Run Migrations (if you added structured collections or indexes):**
   ```bash
   php artisan migrate
   ```
6. **Compile Assets:**
   ```bash
   npm run build
   ```
7. **Start the Application:**
   ```bash
   php artisan serve
   ```

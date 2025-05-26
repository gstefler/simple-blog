# Simple Blog
## Prerequisites
- docker
- docker-compose

## How to run
In the root directory of the project, run the following command:
```bash
docker compose up -d
```

Note: The seeder runs with each container restart. Multiple runs fail because of duplicate entries. If you want to run the seeder again:
```bash
docker compose down
docker compose up -d
```
Just remove the container and start it again.

# Features
- A fully functional Laravel project, adhering to the specifications
- Inertia.js with Vue.js frontend (Shadcn and Tailwind CSS)
- Authorization with Gates
- Admin user (email: admin@test pw: password)
- Docerized running Laravel Octane and MariaDB

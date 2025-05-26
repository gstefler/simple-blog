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

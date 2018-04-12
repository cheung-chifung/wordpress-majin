
clean:
	@docker-compose down
	@(docker stop wordpress-majin 2>/dev/null && docker rm wordpress-majin 2>/dev/null) || echo "wordpress-majin is cleaned"
	@(docker stop wordpress-db-majin 2>/dev/null && docker rm wordpress-db-majin 2>/dev/null) || echo "wordpress-db-majin is cleaned"

init:
	@./wpcli.sh wp core install --url=http://localhost:8000 --title=DUMMY --admin_user=dummy --admin_email=dummy@dummy.com

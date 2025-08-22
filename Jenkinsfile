pipeline {
  agent any

  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
          sh 'docker compose stop react-php'
          sh 'docker compose stop react-app' 
        }
      }
    }
  }
  post {
    always {
      echo 'Cleaning up Docker Compose rebuilding Containers'
      dir('core-dependency') {
        // 1. Tear down all services and remove orphaned resources
      sh 'docker compose down --remove-orphans || true'

      // 2. Clean up lingering network if still present
      sh 'docker network rm core-dependency_checklist-v2-networks || true'

      // 3. Rebuild and restart only necessary services
      sh 'docker compose up --no-deps --build -d react-php'
      sh 'docker compose up --no-deps --build -d react-app'
      }
    }
    success {
      echo 'Pipeline succeeded!'
    }
    failure {
      echo 'Pipeline failed!'
    }
  }
}



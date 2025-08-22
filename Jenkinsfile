pipeline {
  agent any

  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
          sh 'docker-compose stop react-php || true'
          sh 'docker-compose stop react-app || true'
        }
      }
    }
  }

  post {
    always {
      echo 'Cleaning up and rebuilding Docker Compose containers'

      dir('core-dependency') {
        // 1. Tear down all services and remove orphans
        sh 'docker-compose down --remove-orphans || true'

        // 2. Force remove network if stale
        sh 'docker network rm core-dependency_checklist-v2-networks || true'

        // 3. Restart necessary services cleanly
        sh 'docker-compose up -d react-php react-app'
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



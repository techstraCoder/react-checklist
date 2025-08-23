pipeline {
  agent any
  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
          // 1. Tear down existing services and orphans
          sh 'docker-compose down --remove-orphans'
          // 2. Attempt to remove stale network
          sh 'docker network rm core-dependency_checklist-v2-networks || true'
        }
      }
    }
  }
  post {
    always {
      echo 'Cleaning up and rebuilding Docker Compose containers'
      dir('core-dependency') {
        // 3a. Poll until no lingering compose project resources
        sh '''
        PROJECT="core-dependency"
        until [ -z "$(docker network ls --filter label=com.docker.compose.project="${PROJECT}" -q)" ]; do
          echo "Waiting for existing networks to clear..."
          sleep 2
        done
        '''

        // 3b. Use docker system prune as fallback
        sh 'docker system prune -af'

        // 3c. Bring services back up
        sh 'docker-compose up -d'
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




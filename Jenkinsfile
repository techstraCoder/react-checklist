pipeline {
  agent any

  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh '/usr/local/bin/docker-compose down'
          sh '/usr/local/bin/docker-compose up -d'
        }
      }
    }
  }

  post {
    success {
      echo 'Pipeline succeeded!'
    }
    failure {
      echo 'Pipeline failed!'
    }
  }
}


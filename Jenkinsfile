pipeline {
  agent any

  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
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


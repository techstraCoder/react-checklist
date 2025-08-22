pipeline {
  agent any

  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
          sh 'docker-compose down'
        }
      }
    }
  }

  post {
    always {
      echo 'Cleaning up Docker Compose...'
      dir('core-dependency') {
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



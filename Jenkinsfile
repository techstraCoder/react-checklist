pipeline {
  agent any
  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('checklist-frontend') {
          sh 'docker-compose --version'
          sh 'docker build --no-cache .'
        }
      }
    }
  }
  post {
    always {
      echo 'Cleaning up and rebuilding Docker Compose containers'
      dir('core-dependency') {
        sh 'docker-compose up --build -d'
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

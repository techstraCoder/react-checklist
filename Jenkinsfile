pipeline {
  agent any
  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
          sh 'docker compose -f docker-compose.yml down'
        }
      }
    }
  }
  post {
    always {
      echo 'Cleaning up and rebuilding Docker Compose containers'
      dir('core-dependency') {
        sh 'docker compose -f docker-compose.yml up --build --force-recreate -d'
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

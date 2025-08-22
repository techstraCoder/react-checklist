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
        sh 'docker-compose up --no-deps --build -d react-php'
        sh 'docker-compose up --no-deps --build -d react-app'
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



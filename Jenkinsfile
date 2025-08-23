pipeline {
  agent any
  stages {
    stage('Deploy with Docker Compose') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose --version'
          sh 'npm --version'
        }
      }
    }
  }
  post {
    always {
      echo 'Cleaning up and rebuilding Docker Compose containers'
      dir('core-dependency') {
        sh 'nvm --version'
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

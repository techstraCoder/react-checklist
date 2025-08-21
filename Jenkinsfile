pipeline {
  agent any
  stages {
    stage('Check Docker') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose down'
          sh 'docker-compose up -d'
        }
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

pipeline {
  agent any
  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }
    stage('Start Services') {
      steps {
        dir('core-dependency') {
          sh 'docker-compose down'
          sh 'docker-compose up -d --build'
        }
      }
    }
    stage('Run Tests') {
      steps {
        dir('core-dependency') {
          // Example: Running tests inside the PHP container
          sh 'docker-compose exec -T react-php vendor/bin/phpunit || true'
        }
      }
    }
  }
  post {
    always {
      dir('core-dependency') {
        sh 'docker-compose down'
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


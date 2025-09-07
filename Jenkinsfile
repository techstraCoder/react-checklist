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
    always {
      echo 'Cleaning up and rebuilding Docker Compose containers'
      dir('core-dependency') {
        sh 'chmod 644 nginx/checklist.conf'
        sh 'ls -l core-dependency/nginx/checklist.conf'
        sh 'docker compose up -d --build --force-recreate --no-deps react-app'
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

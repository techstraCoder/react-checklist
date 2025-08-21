pipeline {
  agent {
    docker {
      image 'docker:latest'
      args '-v /var/run/docker.sock:/var/run/docker.sock'
    }
  }
  stages {
    stage('Compose Up') {
      steps {
        sh 'apk add docker-compose'         // or install compose in Dockerfile
        sh 'docker-compose up -d --build'
      }
    }
  }
}

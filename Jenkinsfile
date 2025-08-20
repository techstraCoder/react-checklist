pipeline {
  agent any
  stages {
    stage('Compose Up') {
      steps {
        sh 'docker composer -v'
        sh 'docker composer build --no-cache' 
      }
    }
  }
}


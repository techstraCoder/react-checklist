pipeline {
    agent any
    stages {
        stage('Check Docker') {
            steps {
                dir('core-dependency') {
                    sh 'docker compose -v'
                    sh 'docker compose up -d --build'
                }
            }
        }
    }
    post {
        success {
            echo 'Pipeline succeeded!'
        }
        failure {
            echo 'Pipeline failed!'
        }
    }
}


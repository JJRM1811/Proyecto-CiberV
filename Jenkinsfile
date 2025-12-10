pipeline {
    agent any

    environment {
        SONAR_AUTH_TOKEN = credentials('sonar-token')
    }

    stages {

        stage('Checkout') {
            steps {
                echo "Descargando código desde GitHub..."
                checkout scm
            }
        }

        stage('Build') {
            steps {
                echo "Compilando o probando..."
                sh 'echo Build exitoso'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                echo "Ejecutando análisis en SonarQube..."

                withSonarQubeEnv('sonar-server') {

                    script {
                        def scannerHome = tool 'sonar-scanner'   // DEBE llamarse igual que tu instalación en Jenkins

                        withEnv(["PATH+SONAR=${scannerHome}/bin"]) {
                            sh """
                                sonar-scanner \
                                -Dsonar.projectKey=proyecto-ci-demo \
                                -Dsonar.sources=. \
                                -Dsonar.host.url=http://192.168.31.232:9000 \
                                -Dsonar.login=$SONAR_AUTH_TOKEN
                            """
                        }
                    }
                }
            }
        }
    }
}

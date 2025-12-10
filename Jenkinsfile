pipeline {
    agent any

    // ESTO ES LO QUE TE FALTA PARA QUE ARRANQUE SOLO
    triggers {
        pollSCM '* * * * *'
    }

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

        stage('Build & Docker') {
            steps {
                echo "Compilando y creando imagen..."
                // Agregamos esto para cumplir con el requisito de Docker del proyecto
                sh 'docker build -t proyecto-semestral:v1 .' 
            }
        }

        stage('SonarQube Analysis') {
            steps {
                echo "Ejecutando análisis en SonarQube..."
                // Asegúrate que 'sonar-sever' coincida con el nombre en: Administrar Jenkins > System
                withSonarQubeEnv('sonar-server') { 
                    script {
                        def scannerHome = tool 'sonar-scanner'
                        withEnv(["PATH+SONAR=${scannerHome}/bin"]) {
                            sh """
                                sonar-scanner \
                                -Dsonar.projectKey=semestral-ciberv \
                                -Dsonar.sources=. \
                                -Dsonar.host.url=http://192.168.80.147:9000 \
                                -Dsonar.login=$SONAR_AUTH_TOKEN
                            """
                        }
                    }
                }
            }
        }
    }
}

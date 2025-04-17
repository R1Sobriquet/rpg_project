// Fichier JavaScript pour les interactions

document.addEventListener('DOMContentLoaded', function() {
    // Sélection d'éléments du formulaire
    const classeSelect = document.getElementById('classe');
    const forceInput = document.getElementById('force');
    const agiliteInput = document.getElementById('agilite');
    const intelligenceInput = document.getElementById('intelligence');
    const pointsDeVieInput = document.getElementById('pointsDeVie');
    const pointsDeMagieInput = document.getElementById('pointsDeMagie');
    
    // Valeurs par défaut selon la classe
    const defaultStats = {
        'Guerrier': {
            force: 70,
            agilite: 50,
            intelligence: 30,
            pointsDeVie: 200,
            pointsDeMagie: 50
        },
        'Mage': {
            force: 30,
            agilite: 40,
            intelligence: 80,
            pointsDeVie: 100,
            pointsDeMagie: 200
        },
        'Archer': {
            force: 50,
            agilite: 75,
            intelligence: 50,
            pointsDeVie: 150,
            pointsDeMagie: 80
        }
    };
    
    // Fonction pour mettre à jour les statistiques selon la classe
    function updateStatsBasedOnClass() {
        const selectedClass = classeSelect.value;
        
        if (selectedClass && defaultStats[selectedClass]) {
            const stats = defaultStats[selectedClass];
            
            // Mise à jour des valeurs des champs
            forceInput.value = stats.force;
            agiliteInput.value = stats.agilite;
            intelligenceInput.value = stats.intelligence;
            pointsDeVieInput.value = stats.pointsDeVie;
            pointsDeMagieInput.value = stats.pointsDeMagie;
        }
    }
    
    // Écouter les changements de classe
    if (classeSelect) {
        classeSelect.addEventListener('change', updateStatsBasedOnClass);
    }
    
    // Validation du formulaire
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            // Vérifier que tous les champs requis sont remplis
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            // Vérifier que les statistiques sont des nombres valides
            const statFields = [forceInput, agiliteInput, intelligenceInput, pointsDeVieInput, pointsDeMagieInput];
            
            statFields.forEach(field => {
                if (field && (isNaN(field.value) || field.value < 1)) {
                    isValid = false;
                    field.classList.add('error');
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert('Veuillez remplir correctement tous les champs du formulaire.');
            }
        });
    }
    
    // Effet visuel pour les cartes de personnages s'ils existent
    const characterCards = document.querySelectorAll('.character-card');
    if (characterCards.length > 0) {
        characterCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.classList.add('card-hover');
            });
            
            card.addEventListener('mouseout', function() {
                this.classList.remove('card-hover');
            });
        });
    }
});
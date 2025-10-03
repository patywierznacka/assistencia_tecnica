<?php
// includes/footer.php
?>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>WIERZNACKA.INFO</h3>
                <p>Sistema de Gestão para Assistência Técnica</p>
                <div class="contact-info">
                    <p><strong>Proprietário:</strong> Wierznacka</p>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Contato</h4>
                <div class="contact-details">
                    <div class="contact-item">
                        <span class="contact-icon">📞</span>
                        <span>(55) 98441-2458</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📱</span>
                        <span>(55) 98419-1853</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">✉️</span>
                        <span>patywrocha2020@gmail.com</span>
                    </div>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Endereço</h4>
                <div class="address">
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <span>
                            Rua tabaja dias da rosa, 36<br>
                            Urlandia - Santa maria/RS<br>
                            CEP: 97070-650
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Horário de Funcionamento</h4>
                <div class="business-hours">
                    <div class="hours-item">
                        <span>Segunda a Sexta:</span>
                        <span>08:00 - 18:00</span>
                    </div>
                    <div class="hours-item">
                        <span>Sábado:</span>
                        <span>08:00 - 12:00</span>
                    </div>
                    <div class="hours-item">
                        <span>Domingo:</span>
                        <span>Fechado</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="social-links">
                <a href="#" class="social-link" title="Facebook">
                    <span>📘</span>
                </a>
                <a href="#" class="social-link" title="Instagram">
                    <span>📷</span>
                </a>
                <a href="#" class="social-link" title="WhatsApp">
                    <span>💬</span>
                </a>
                <a href="#" class="social-link" title="Email">
                    <span>📧</span>
                </a>
            </div>
            <p>&copy; 2025 WIERZNACKA.INFO - Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

<style>
.footer {
    background-color: var(--secondary-color);
    color: var(--primary-color);
    padding: 2rem 0 1rem;
    margin-top: 3rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.footer-section h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.footer-section p {
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.contact-info {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
}

.contact-details,
.address,
.business-hours {
    margin-top: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.contact-icon {
    margin-right: 0.5rem;
    min-width: 20px;
}

.hours-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.1);
}

.hours-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 215, 0, 0.3);
    padding-top: 1rem;
    text-align: center;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: var(--primary-color);
    color: var(--secondary-color);
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background-color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.footer-bottom p {
    margin: 0;
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .footer-section {
        text-align: center;
    }
    
    .contact-item {
        justify-content: center;
        text-align: center;
    }
    
    .hours-item {
        justify-content: space-around;
    }
    
    .social-links {
        gap: 0.5rem;
    }
    
    .social-link {
        width: 35px;
        height: 35px;
    }
}

@media (max-width: 480px) {
    .footer {
        padding: 1.5rem 0 1rem;
    }
    
    .footer-content {
        gap: 1rem;
    }
    
    .footer-section h3 {
        font-size: 1.3rem;
    }
    
    .footer-section h4 {
        font-size: 1rem;
    }
}
</style>
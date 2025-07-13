<footer class="footer">
    <div class="footer-content">
        <div class="footer-text">
            <p>© {{ date('Y') }} All rights reserved by 
                <a href="#" target="_blank" class="footer-link">ERPedia</a>
            </p>
        </div>
        
        <div class="footer-links">
            <a href="#" class="footer-link">Privacy Policy</a>
            <span class="footer-separator">•</span>
            <a href="#" class="footer-link">Terms of Service</a>
            <span class="footer-separator">•</span>
            <a href="#" class="footer-link">Support</a>
        </div>
    </div>
</footer>

<style>
.footer {
    padding: 24px;
    border-top: 1px solid var(--border-color);
    background: white;
    margin-top: auto;
}

.footer-content {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;
    max-width: 1200px;
    margin: 0 auto;
    flex-wrap: wrap;
}

.footer-text {
    margin: 0;
}

.footer-text p {
    margin: 0;
    font-size: 14px;
    color: var(--text-secondary);
}

.footer-links {
    display: flex;
    align-items: center;
    gap: 12px;
}

.footer-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.2s ease;
}

.footer-link:hover {
    color: var(--secondary-color);
}

.footer-separator {
    color: var(--text-secondary);
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
    
    .footer-links {
        justify-content: center;
    }
}
</style>

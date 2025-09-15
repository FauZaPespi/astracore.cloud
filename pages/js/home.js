// Function for full-console hero vibes
function consoleHero() {
    // Title
    console.log(
        `%cAstraCore`,
        `font-size: 3rem;
       font-weight: 900;
       background: linear-gradient(135deg, #ffffff, #10b981);
       -webkit-background-clip: text;
       -webkit-text-fill-color: transparent;
       text-align: center;
       display: block;
       padding: 12px 0;
       margin-bottom: 0.5rem;`
    );
    // Description text
    console.log(
        `%cAstraCore is the next-generation SaaS platform for centralized Linux server management.\nControl your entire infrastructure from a single, powerful interface.`,
        `font-size: 1rem;
       color: #cbd5e1;
       text-align: center;
       display: block;
       line-height: 1.5;
       margin-bottom: 1rem;`
    );

    for (let i = 0; i < 3; i++) {
        console.log(""); // Spacer lines
    }
    for (let i = 0; i < 3; i++) {
        // Warning message
        console.log(
            `%c⚠️ Don't paste unknown code here! You could lose your account.`,
            `font-size: 1rem;
         font-weight: 700;
         color: #f87171;
         text-align: center;
         display: block;
         padding: 6px 0;`
        );
        console.log(""); // Spacer lines
    }


}

// Call it
consoleHero();

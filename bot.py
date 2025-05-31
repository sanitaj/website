from telegram import Update
from telegram.ext import ApplicationBuilder, CommandHandler, ContextTypes
import os

async def start(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("бот не работает")

if __name__ == '__main__':
<<<<<<< HEAD
    token = os.getenv("BOT_TOKEN")  # безопасно получаем токен из переменной окружения
=======
    token = os.getenv("BOT_TOKEN") 
>>>>>>> 745b3a5 (upd)
    app = ApplicationBuilder().token(token).build()
    app.add_handler(CommandHandler("start", start))
    app.run_polling()

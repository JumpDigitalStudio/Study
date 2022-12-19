using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace PracticalWork_15
{
    /// <summary>
    /// Логика взаимодействия для NewDrawNote.xaml
    /// </summary>
    public partial class NewDrawNote : Window
    {
        // Инициализация программы
        public NewDrawNote()
        {
            InitializeComponent();
        }



        // Создание нового рисунка
        public NewDrawNote(Note note)
        {
            InitializeComponent();
            FileStream fs = new FileStream(note.Path, FileMode.Open);
            NoteCanvas.Strokes = new StrokeCollection(fs);
            NoteName.Text = note.Name;
            fs.Close();
        }



        // Сохранение рисунка
        private void SaveButton_Click(object sender, RoutedEventArgs e)
        {
            string title = NoteName.Text;
            if (title == "" || title == " ")
            {
                MessageBox.Show("Придумайте название заметки", "Внимание");
                return;
            }

            string exeDir = AppDomain.CurrentDomain.BaseDirectory;
            string relPath = @"..\data"; // Относительный путь к файлу
            string resPath = System.IO.Path.Combine(exeDir, relPath); // Объединяет две строки в путь.
            string currentDirectory = System.IO.Path.GetFullPath(resPath); // Возвращает для указанной строки пути абсолютный путь.

            string path = $"{currentDirectory}\\{title}.isf";
            if (!File.Exists(path))
            {
                FileStream fs = new FileStream(path, FileMode.Create);
                NoteCanvas.Strokes.Save(fs);
                fs.Close();

                MainWindow PageAllNotes = new MainWindow();
                PageAllNotes.Show();
                this.Hide();
            }
            else
            {
                if (MessageBox.Show("Заметка с таким именем уже существует, перезпаписать?", "Внимание", MessageBoxButton.YesNo) == MessageBoxResult.Yes)
                {
                    FileStream fs = new FileStream(path, FileMode.Create);
                    NoteCanvas.Strokes.Save(fs);
                    fs.Close();

                    MainWindow PageAllNotes = new MainWindow();
                    PageAllNotes.Show();
                    this.Hide();
                }
            }
        }
        // Возврат к начальному окну
        private void BackButton_Click(object sender, RoutedEventArgs e)
        {
            MainWindow PageAllNotes = new MainWindow();
            PageAllNotes.Show();
            this.Hide();
        }
    }
}

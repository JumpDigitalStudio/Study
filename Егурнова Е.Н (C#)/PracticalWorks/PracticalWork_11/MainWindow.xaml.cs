using Microsoft.Win32;
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
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace PracticalWork_11
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {

        public MainWindow()
        {
            InitializeComponent();
            cmbFont.ItemsSource = Fonts.SystemFontFamilies.OrderBy(f => f.Source);
            cmbFontSize.ItemsSource = new List<double>() { 8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28, 36, 48, 72 };
        }

        private void Save(object sender, ExecutedRoutedEventArgs e)
        {
            SaveFileDialog dlg = new SaveFileDialog();
            dlg.Filter = "Rich Text Format (*.rtf)|*.rtf|All files (*.*)|*.*";
            if (dlg.ShowDialog() == true)
            {
                FileStream fileStream = new FileStream(dlg.FileName, FileMode.Create);
                TextRange range = new TextRange(rtbEditor.Document.ContentStart, rtbEditor.Document.ContentEnd);
                range.Save(fileStream, DataFormats.Rtf);
            }
        }

        private void cmbFont_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {
            if (cmbFont.SelectedItem != null)
                rtbEditor.Selection.ApplyPropertyValue(Inline.FontFamilyProperty, cmbFont.SelectedItem);
        }

        private void cmbFontSize_TextChanged(object sender, TextChangedEventArgs e)
        {
            rtbEditor.Selection.ApplyPropertyValue(Inline.FontSizeProperty, cmbFontSize.Text);
        }
        internal class Memento
        {
            public State State { get; set; }

            public Memento(State state)
            {
                State = state;
            }
        }
        internal class State
        {
            public string Text { get; set; } = "";
            public int FontSize { get; set; } = 12;
            public bool Italic { get; set; } = false;
            public bool Bold { get; set; } = false;
            public bool Underline { get; set; } = false;

            public State() { }

            public State(string text, int fontSize, bool italic, bool bold, bool underline)
            {
                Text = text;
                FontSize = fontSize;
                Italic = italic;
                Bold = bold;
                Underline = underline;
            }
        }
        internal class Caretaker
        {
            public List<State> Stetes = new List<State>();
        }
        internal class Originator
        {
            public State State { get; set; } = new State();
            public void SetMemento(Memento memento)
            {
                State = memento.State;
            }
            public Memento CreateMemento()
            {
                return new Memento(State);
            }
        }
    }
}

namespace Portal.Model
{
    public class LeadItem
    {
        public string Title { get; set; }
        public string Company { get; set; }
        public string Stage { get; set; }

        public LeadItem(string title, string company, string stage)
        {
            Title = title;
            Company = company;
            Stage = stage;
        }
    }
}

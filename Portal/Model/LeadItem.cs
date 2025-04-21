namespace Portal.Model
{
    public class LeadItem
    {
        public string CustomerName;
        public string ContactPerson;
        public string Email;
        public string Phone;
        public string LeadStatus;
        public string LeadSource;
        public string IndustrySegment;
        public string CustomerCategory;
        public List<ProductItem> ProductNeeds = new();
        public string AdditionalNotes;
        public string Title { get; set; }
        public string Company { get; set; }
        public string Stage { get; set; }

        public LeadItem()
        {
        }
        public LeadItem(string title, string company, string stage)
        {
            Title = title;
            Company = company;
            Stage = stage;
        }
    }
}
